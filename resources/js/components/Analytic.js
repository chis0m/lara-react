import {imageUrl} from "../utilities";

const Analytic = ( { productAnalysis, title } ) => {
    return (
        <div className="flow-root">
                    <ul role="list" className="divide-y divide-gray-200">
                        <li className="py-3 sm:py-4">
                            <div className="flex items-center space-x-4">
                                <div className="flex-shrink-0">
                                    <img className="w-12 h-12 rounded-full" src={ imageUrl(productAnalysis.name) } alt={ productAnalysis.name } />
                                </div>
                                <div className="flex-1 min-w-0">
                                    <p className="text-sm font-medium text-gray-900 truncate">{ productAnalysis.name }</p>
                                </div>
                                <div
                                    className="inline-flex items-center text-base font-semibold text-gray-900">
                                    { (title === 'removal') ? productAnalysis.total_count : productAnalysis.total_count }
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
    )
}

export default Analytic
