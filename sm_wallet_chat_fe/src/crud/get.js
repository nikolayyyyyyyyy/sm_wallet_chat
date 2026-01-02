const base_path = 'http://127.0.0.1:8000/api';

const getItem = async (slug, id) => {
    const response = await fetch(`${base_path}/${slug}/${id}`,{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    });

    const user = await response.json();

    return user; 
};

export default function get() {
    return {
        getItem
    }
}