import PropTypes from 'prop-types';
import { imageUrl } from '../utilities'

const Product = ({ product: { id, price, name }, addToCart }) => {
    return (
        <div className="py-6 h-64">
            <div className="flex max-w-sm bg-white shadow-lg rounded-lg overflow-hidden">
                <div className="w-1/3 bg-cover"
                     style={ {backgroundImage: `url(${imageUrl(name)})`} }>
                </div>
                <div className="w-2/3 p-4">
                    <h1 className="text-gray-900 font-bold text-xl">{name}</h1>
                    <p className="mt-2 text-gray-600 text-sm line-clamp-2">Lorem ipsum dolor sit amet consectetur adipisicing elit In
                        odit exercitationem fuga id nam quia</p>
                    <div className="flex item-center justify-between mt-3">
                        <h1 className="text-gray-700 font-bold text-base">${ price }</h1>
                        <button className="px-3 py-2 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold uppercase rounded cursor-pointer" onClick={() => addToCart(id, name)}>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}

Product.propTypes = {
    product: PropTypes.object.isRequired
}

export default Product
