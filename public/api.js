window.data = {
    get: async function(url) {
        const res = await fetch(url)
        const json = await res.json()
        return json
    }
}
