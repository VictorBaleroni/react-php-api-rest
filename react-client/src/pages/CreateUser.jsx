import { useState } from 'react'
import '../styles/CreateUser.css'
import axios from "axios"

const CreateUser = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: ""  
  })

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
      await axios.post("http://localhost:8080/userpost", formData)
      .then(({data}) => {
        console.log(data)
      }).catch((error) => {
        console.error("There was an error!", error)
      })
  }

  return (
  <>
    <div className='container'>
        <form className='form-create-user' onSubmit={handleSubmit}>
            <h1 className='create-user-text'>Create Account</h1>
          <div>
            <input type="text" className='input-name' name='name' placeholder='name' value={formData.name} onChange={handleChange} />
          </div>
          <div>
            <input type="email" className='input-email' name='email' placeholder='email' value={formData.email} onChange={handleChange} />
          </div>
          <div>
            <input type="password" className='input-password' name='password' placeholder='password' value={formData.password} onChange={handleChange} />
          </div>
          <div>
            <input type="submit" className='create-button' value="Create" />
          </div>
        </form>
    </div>
  </>
  )
}

export default CreateUser