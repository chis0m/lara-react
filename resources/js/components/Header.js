import {FaShoppingCart} from 'react-icons/fa'
import {Link} from 'react-router-dom'

const Header = ({ numberOfItems, storeCart, isLoggedIn, logout, user }) => {


    const alertAuth = ( ) => {
        if(user.role !== 'admin') return alert('You must be admin to access')
    }

    return (
        <div className="relative bg-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6">
                <div className="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                    <div className="flex justify-start lg:w-0 lg:flex-1">
                        <Link to='/' href="#">
                            <span className="sr-only">Meetroger</span>
                            <FaShoppingCart className='text-indigo-600 text-2xl' />
                        </Link>
                    </div>
                    <nav className="hidden md:flex space-x-10">
                        <div className="relative">
                            <Link to='/' className=''>
                                <button type="button" className="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none" aria-expanded="false">
                                    <span>Products</span>
                                </button>
                            </Link>
                        </div>
                        <Link to='/carts' onClick={storeCart} className="text-base font-medium text-gray-500 hover:text-gray-900"><span> My Cart </span></Link>
                        <div className="relative">
                            {
                                <Link to='/analytics' onClick={() => alertAuth()} >
                                    <button type="button" className="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none" aria-expanded="false">
                                        <span>Analytics</span>
                                    </button>
                                </Link>
                            }
                        </div>
                    </nav>
                    <div className="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                        <Link to='/carts' onClick={storeCart} className="mx-4 whitespace-nowrap inline-flex space-x-1 items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            <FaShoppingCart/> <span className='font-bold' >{numberOfItems}</span>
                        </Link>
                    </div>

                    <div className="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                        {
                            (!isLoggedIn) ? (
                                <Link
                                    to='/login'
                                      className="ml-4 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                                > Login </Link>

                            ) : (
                                <Link to='/' onClick={() => logout()} className="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold uppercase rounded cursor-pointer">Logout</Link>
                            )
                        }
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Header
