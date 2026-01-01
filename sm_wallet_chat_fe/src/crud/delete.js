const baseUrl = 'http://127.0.0.1:8000/api';

const deleteItem = async (slug ,id) => {
    await fetch(`${baseUrl}/${slug}/${id}/delete`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
};

export function _delete() {
    return {
        deleteItem
    }
}