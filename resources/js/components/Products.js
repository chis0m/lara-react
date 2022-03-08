import Product from './Product'

const Products = ({ products, addToCart }) => {
    return (
        <div className='grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-4'>
            {
                products.map(
                    (product, index) => ( <Product key={index} product={product} addToCart={addToCart} />)
                )
            }
        </div>
    );
}


export default Products
