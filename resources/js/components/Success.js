import { useLocation, useNavigate } from 'react-router-dom'


const Success = ({ checkoutSuccess }) => {
    return (
        <div className='flex justify-center items-center mt-6 w-full'>
            <div className="relative flex flex-col items-center bg-white shadow rounded-md py-5 pl-6 pr-8 sm:pr-6">
                <div className="flex flex-col items-center border-b sm:border-b-0 w-full sm:w-auto pb-2 sm:pb-0">
                    <div className="text-green-500">
                        <svg className="w-6 sm:w-16 h-6 sm:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div className="text-sm font-medium mt-1 ml-3">Success Checkout.</div>
                </div>
                <div className="text-sm tracking-wide text-gray-500 sm:mt-0 sm:ml-4">Your purchase was successful. Do pay on delivery!</div>
            </div>

        </div>
    )
}

export default Success;
