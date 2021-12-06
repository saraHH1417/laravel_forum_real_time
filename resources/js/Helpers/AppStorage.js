class AppStorage {
    storeToken (token) {
         localStorage.setItem('token' , token)
    }

    storeUser(username) {
       localStorage.setItem('username' , username)
    }

    store(token,username){
        this.storeToken(token)
        this.storeUser(username)
    }

    clear() {
        localStorage.removeItem('token')
        localStorage.removeItem('username')
    }

    getToken() {
        return localStorage.getItem('token')
    }

    getUsername() {
        return localStorage.getItem('username')
    }
}

export default AppStorage = new AppStorage();
