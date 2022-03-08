import Cart from "./Cart";
import { FaCreditCard } from "react-icons/fa";
import { Link, Navigate } from "react-router-dom";

const Carts = ( { carts, updateACart, checkout, isLoggedIn } ) => {
    return (
        <>
            {
                isLoggedIn ? (
                    (!carts || carts.length === 0)
                        ? <h4 className='text-center my-10'> Cart Is Empty</h4>
                        :
                        (
                            <div>
                                <div className='grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 py-10'  >
                                    {
                                        carts.map(
                                            (cart, index) => ( <Cart key={index} cart={ cart } updateACart={updateACart}   /> )
                                        )
                                    }
                                </div>
                                <div className='flex justify-center items-center my-3'>
                                    <Link to='/success' onClick={checkout}>
                                        <button
                                            className="flex justify-center items-center px-10 py-3 bg-indigo-600 hover:bg-gray-700 text-white text-xl font-bold uppercase rounded-lg cursor-pointer">
                                            Checkout <span className='text-xl pl-4'><FaCreditCard /></span>
                                        </button>

                                    </Link>
                                </div>
                            </div>
                        )
                ) : (<Navigate to={'/login'} />)
            }


        </>
    )
}


export default Carts;
