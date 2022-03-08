import { useState } from 'react'

const Login = ( { onLogin } ) => {
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')

    const onSubmit = async (e) => {
        e.preventDefault()
        if(!email) {
            return alert('Email is required')
        }
        if(!password) {
            return alert('Password is required')
        }
        await onLogin(email, password)
    }

    return (
        <div className='flex justify-center items-center mt-10'>
            <div className="w-full max-w-lg">
                <form className="bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4" onSubmit={onSubmit}>
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="email">
                            Email
                        </label>
                        <input
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" type="email" placeholder="email" />
                    </div>
                    <div className="mb-6">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                            Password
                        </label>
                        <input
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            className="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" type="password" placeholder="password" />
                    </div>
                    <div className="flex items-center justify-between">
                        <button
                            className="bg-indigo-500 hover:bg-indigo-800 text-white font-bold py-2 w-full rounded focus:outline-none focus:shadow-outline"
                            type="submit"
                            >
                           Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

    )
}

export default Login
