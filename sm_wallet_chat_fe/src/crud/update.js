const baseUrl = 'http://127.0.0.1:8000/api';

const updateData = async (data, slug, id) => {
    const response = await fetch(`${baseUrl}/${slug}/${id}/update`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: data
    });
    if (!response.ok) {
        const errors = await response.json();
        throw new Error(JSON.stringify(errors));
    }
};

export function update() {
    return {
        updateData
    }
}