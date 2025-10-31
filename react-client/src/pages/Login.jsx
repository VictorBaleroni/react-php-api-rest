import '../styles/login.css'
import axios from "axios";

const Login = () => {
    return (
        <>
        <div className='container-login'>
            <form className='form-login'>
                <h1 className='login-text'>LOGIN</h1>
              <div>
                <input type="text" className='input-email' placeholder='email' />
              </div>
              <div>
                <input type="text" className='input-password' placeholder='password' />
              </div>
              <div>
                <input className='login-button' type="submit" value="LOGIN" />
              </div>
            </form>
        </div>
        </>
    )
}

export default Login