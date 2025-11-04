import '../styles/CreateUser.css'

const CreateUser = () => {

    
    return (
        <>
        <div className='container'>
            <form className='form-create-user'>
                <h1 className='create-user-text'>Create Account</h1>
              <div>
                <input type="text" className='input-name' placeholder='name' />
              </div>
              <div>
                <input type="email" className='input-email' placeholder='email' />
              </div>
              <div>
                <input type="password" className='input-password' placeholder='password' />
              </div>
              <div>
                <input className='create-button' type="submit" value="Create" />
              </div>
            </form>
        </div>
        </>
    )
}

export default CreateUser