const baseUrl = 'http://127.0.0.1:8000/api';

const create = async (data, slug) => {
    const response = await fetch(`${baseUrl}/${slug}`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(data)
    });

    if (!response.ok) {
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }
};

export function store() {
    return {
        create
    }
}