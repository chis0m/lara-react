import Analytic from "./Analytic";

const Analytics = ( { analytics } ) => {
    const removedProducts = analytics?.removedProducts
    const checkedOutProduct = analytics?.checkedOutProduct

    return (
        <>
            <div className='flex flex-col lg:flex-row justify-center items-center mt-4 space-x-6 w-full'>
                <div className="p-4 max-w-lg bg-white rounded-lg border shadow-lg sm:p-8 h-[32rem] w-[22rem]">
                    <div className="flex justify-center items-center mb-4">
                        <h5 className="text-lg font-bold leading-none text-center text-indigo-600">Number of Checkout per Product</h5>
                    </div>
                    {
                        checkedOutProduct?.map((product, index) => (
                            <Analytic key={index} productAnalysis={product} title={'checkout'} />
                        ))
                    }
                </div>

                <div className="p-4 max-w-lg bg-white rounded-lg border shadow-lg sm:p-8 h-[32rem] w-[22rem]">
                    <div className="flex flex-col justify-center items-center mb-4">
                        <h5 className="w-full text-lg font-bold leading-none text-center text-indigo-600">Product Removal Frequency</h5>
                        <p className="w-full text-xs italic font-bold leading-none text-center text-indigo-600">After adding to cart</p>
                    </div>
                    {
                        removedProducts?.map((product, index) => (
                            <Analytic key={index} productAnalysis={product} title={'removal'} />
                        ))
                    }
                </div>
            </div>
        </>

    )
}

export default Analytics;
