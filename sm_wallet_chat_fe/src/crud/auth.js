import { ref } from "vue";

const base_path = 'http://127.0.0.1:8000/api';

const is_logged = ref(localStorage.getItem('token') != null);

const register = async(user) => {
    const response = await fetch(`${base_path}/register`,{
        method: 'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    });

    if(!response.ok){
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }
};

const login = async (user) => {
    const response = await fetch(`${base_path}/login`,{
        method: 'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    });

    if(response.ok){
        const token = await response.json();
        localStorage.setItem('token', token.token);
        is_logged.value = true;
    }else {
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }
}

const logout = async () => {
    await fetch(`${base_path}/logout`,{
        method: 'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    });
    localStorage.removeItem('token');
    is_logged.value = false;
}

export default function auth() {
    return {
        login,
        is_logged,
        logout,
        register
    }
}