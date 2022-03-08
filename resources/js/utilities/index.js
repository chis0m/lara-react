const data = {
    imageUrl: (name) => {
        if(name.toLowerCase().includes('dj mixer'))
            return '/images/mixer.jpeg'
        if(name.toLowerCase().includes('sampler'))
            return '/images/sampler.jpeg'
        if(name.toLowerCase().includes('headphone'))
            return '/images/headphone.jpeg'
        if(name.toLowerCase().includes('monitor'))
            return '/images/monitor.jpeg'
        if(name.toLowerCase().includes('baby'))
            return '/images/baby-mixer.jpeg'

        return '/images/headphone.jpeg'
    },

    CartStatus: {
        ADDED: 1,
        REMOVED: 2,
        CHECKED_OUT: 3,
    }
}

module.exports = data
