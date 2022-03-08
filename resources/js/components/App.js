import {useEffect, useState} from 'react'
import ReactDOM from 'react-dom'
import {BrowserRouter, Navigate, Route, Routes} from 'react-router-dom'
import Header from './Header'
import Products from './Products'
import Login from './Login'
import Carts from "./Carts";
import {CartStatus} from '../utilities'
import Success from "./Success";
import Analytics from "./Analytics";


const App = () => {
    const baseUrl = process.env.MIX_API_URL
    const [user, setUser] = useState({})
    const [isLoggedIn, setIsLoggedIn] = useState(false)
    const [ products, setProduct ] = useState([])
    const [ analytics, setAnalytics ] = useState({})
    const [carts, setCarts ] = useState([])
    const [items, setItems ] = useState(0)
    const [checkoutSuccess, setCheckoutSuccess] = useState(false)

    const token = localStorage.getItem('token');
    const config = {
        headers: { Authorization: `Bearer ${token}` }
    };

    useEffect( () => {
        const authenticate =  async () => {
            await getAuth()
        }
        authenticate()

        const fetchAnalysisData = async () => {
            await fetchAnalytics()
        }
        fetchAnalysisData()

        const fetchProductData = async  () => {
            const products = await fetchProducts()
            setProduct(products)
        }
        fetchProductData()

    }, [])

    /**
     * @description Login a user
     * @param email
     * @param password
     */
    const onLogin = async (email, password) => {
        try{
            const response = await window.axios.post(`${baseUrl}/login`, { email, password }, config)
            const data = response.data.data
            setUser(data.user)
            updateAuth(data.token)
            await preloadCart(data.user)
        } catch (e) {
            alert(e.response.data.message || 'Login unsuccessful')
        }
    }

    /**
     * @description logout a user
     */
    const logout = async () => {
        updateAuth(false)
    }

    /**
     * @description Validates session token every time a page is reloaded
     */
    const getAuth = async () => {
        try {
            const response = await window.axios.get(`${baseUrl}/user`, config)
            const userData = response.data.data
            setUser(userData)
            setIsLoggedIn(true)

            await preloadCart(userData)
        } catch (e) {
            updateAuth(null)
        }
    }

    /**
     * @description updates authentication dependencies
     * @param token
     */
    const updateAuth = (token) => {
        if (!token) {
            localStorage.removeItem('token')
            setIsLoggedIn(false)
            return
        }
        localStorage.setItem('token', token)
        setIsLoggedIn(true)
    }

    /**
     * @description calls product fetch api, does not need authentication
     */
    const fetchProducts =  async () => {
        const response = await window.axios.get(`${baseUrl}/products`)
        return  response?.data.data
    }

    /**
     * @description calls analytics api - must be an admin to use this
     */
    const fetchAnalytics =  async () => {
        try {
            const response = await window.axios.get(`${baseUrl}/analytics`, config)
            const data = response?.data.data
            await setAnalytics(data)
        } catch (e) {
        }
    }

    /**
     * @description Reload cart to ensure authenticated user owns cart
     * @param user
     */
    const preloadCart = async (user) => {
        let storedCarts = JSON.parse(localStorage.getItem('carts')) || [];
        if(storedCarts[0].user_id &&  storedCarts[0].user_id !== user.id) {
            storedCarts = []
        }
        await setCarts(storedCarts)
        await getNumberOfItems(storedCarts)
        setCheckoutSuccess(false)

    }

    /**
     * @description calls cart store api - must be logged in to access
     */
    const storeCarts = async () => {
        if(!isLoggedIn) return alert('Do login to continue')
        const response = await window.axios.post(`${baseUrl}/users/${user.id}/carts`, { cart: carts }, config)
        const carton = [];
        response.data.data.forEach(function (el) {
            const cart = {
                id: el.id,
                user_id: el.user_id,
                product_id: el.product_id,
                count: el.count,
                name: el.product.name
            }
            carton.push(cart)
        })
        await cartArrayUpdate(carton)
    }

    /**
     * @description helper function to update cart
     * @param cart
     */
    const updateACart = async (cart) => {
        if(!isLoggedIn) return alert('Do login to continue')
        const raw = {
            status: (cart.count === 0) ? CartStatus.REMOVED : CartStatus.ADDED,
            count: cart.count
        }

        // get index of item before update so as not to change the position after update
        const cartIndex = [null]
        carts.forEach(function (el, index) {
            if(el.id === cart.id) {
                cartIndex[0] = index
            }
        })

        const response = await window.axios.put(`${baseUrl}/users/${user.id}/carts/${cart.id}`, raw, config)
        const data = response.data.data

        if(data.count === 0) {
            const arr = carts.filter(function (cart) {
                return cart.product_id !== data.product_id
            })
            return await cartArrayUpdate(arr)
        }
        const updatedCart = { id: data.id, product_id: data.product_id, count: data.count, name: data.product.name }
        await cartUpdate(updatedCart, updatedCart.product_id, cartIndex[0])
    }

    /**
     * @description calls checkout api - must be authenticated to use this
     */
    const checkout = async () => {
        if(!isLoggedIn) return alert('Do login to continue')
        await window.axios.post(`${baseUrl}/users/${user.id}/checkouts`, { cart: carts }, config)
        await cartArrayUpdate([])
        alert('Hurray, checkout successful !!!')
        return setCheckoutSuccess(true);//empty the cart
    }

    /**
     * @description adds new products to cart
     * @param product_id
     * @param name
     */
    const addToCart = async (product_id, name) => {
        let cart = carts.filter(function (cart) {
            return cart?.product_id === product_id
        })[0]
        const updatedCart = (cart) ? { ... cart, count: cart.count + 1 } : { product_id, name, count: 1 }
        await cartUpdate(updatedCart, product_id)
    }

    /**
     * @description helper function to calculate total number of items in the cart
     * @param carts
     *
     */
    const getNumberOfItems = async (carts) => {
        const numberOfItems =  carts.reduce(function (accumulator, cart) {
            return accumulator + cart.count
        }, 0)
        setItems(numberOfItems)
    }

    /**
     * @description updates cart
     * @param updatedCart
     * @param product_id
     * @param index - used to make sure that products retain their initial positions in the cart
     */
    const cartUpdate = async (updatedCart, product_id, index = null) => {
        const otherCarts = carts.filter(function (cart) {
            return cart?.product_id !== product_id
        })
        if(index !== null) {
            carts[index] = updatedCart
            await cartArrayUpdate(carts)
            return
        }
        const newCarts = [...otherCarts, updatedCart];
        await cartArrayUpdate(newCarts)
    }

    /**
     * @description persist cart in local storage, so as not to loose it on page reload
     * @param carts
     */
    const cartArrayUpdate = async  (carts) => {
        localStorage.setItem('carts', JSON.stringify(carts)) // persist cart
        await setCarts(carts)
        await getNumberOfItems(carts)
    }


    return (
        <BrowserRouter>
            <div className='min-h-screen w-full flex justify-center items-center'>
                <div className='bg-gray-100 rounded-sm w-full lg:w-11/12 xl:w-10/12 h-[45rem] overflow-auto'>
                    <Header
                        numberOfItems={items}
                        storeCart={storeCarts}
                        fetchAnalytics={fetchAnalytics}
                        isLoggedIn={isLoggedIn}
                        logout={logout}
                        user={user}
                    />
                    <div className='px-8'>
                        <Routes>
                            <Route path='/'
                                   element={
                                       <>
                                        <Products products={ products } addToCart={addToCart} />
                                       </>
                                   }
                            />
                            <Route
                                path='/carts'
                                element={
                                    <>
                                        {
                                            isLoggedIn ? (<Carts carts={ carts } updateACart={updateACart} checkout={checkout} isLoggedIn={isLoggedIn}  /> ) :
                                                (<Navigate to={'/'} />)
                                        }

                                    </>
                                }
                            />
                            <Route
                                path='/success'
                                element={
                                    <>
                                        {
                                            (checkoutSuccess && isLoggedIn) ? (
                                                    <Success checkoutSuccess={checkoutSuccess} />
                                                ) :
                                                (<Navigate to={'/'} />)
                                        }
                                    </>
                                }
                            />
                            <Route
                                path='/analytics'
                                element={
                                    <>
                                        {
                                            (Object.keys(analytics).length > 0 && user.role === 'admin') ? (
                                                    <Analytics analytics={analytics} />
                                                ) :
                                                (<Navigate to={'/'} />)
                                        }
                                    </>
                                }
                            />

                            <Route
                                path='/login'
                                element={
                                    <>
                                    {
                                        !isLoggedIn ?
                                            (<Login onLogin={onLogin} />) :
                                            (<Navigate to={'/'} />)
                                    }

                                    </>
                                }
                            />
                        </Routes>
                    </div>
                </div>
            </div>
        </BrowserRouter>
    );
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
