import { imageUrl } from '../utilities'
import {FaPlus, FaMinus} from 'react-icons/fa'
const Cart = ( { cart, updateACart } ) => {

    return  (
        <div className="max-w-xs bg-white rounded-lg shadow-lg">
            <div className="flex flex-col items-center pb-4">
                <img className="my-3 w-24 h-24 rounded-full shadow-lg object-cover object-center" src={imageUrl(cart.name)} alt={cart.name} />
                    <h5 className="mb-1 text-md font-bold text-gray-900">{cart.name}</h5>
                    <span className="text-xl text-gray-800 py-2 font-bold text-center"> { cart.count } </span>
                    <div className="flex mt-1 space-x-3">
                        <button
                            className="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold uppercase rounded cursor-pointer"
                            onClick={() => updateACart( { ...cart, count: cart.count + 1 } ) }
                        >
                            <FaPlus/>
                        </button>
                        <button
                            className="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold uppercase rounded cursor-pointer"
                            onClick={ () => updateACart({ ...cart, count: cart.count - 1 }) }
                        >
                            <FaMinus />
                        </button>
                    </div>
            </div>
        </div>
    )
}

export default Cart;
