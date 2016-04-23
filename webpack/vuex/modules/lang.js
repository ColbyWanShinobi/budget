
const state = {
    current: 'en',
    texts: {
        en: {
            app: {
                title: 'Budget',
            },
            home: {
                title: 'Home',
            },
            accounts: {
                title: 'Accounts',
            },
            envelopes: {
                title: 'Envelopes',
            },
            operations: {
                title: 'Operations',
            },
        },
        fr: {
            app: {
                title: 'Budget',
            },
            home: {
                title: 'Accueil',
            },
            accounts: {
                title: 'Comptes',
            },
            envelopes: {
                title: 'Enveloppes',
            },
            operations: {
                title: 'Opérations',
            },
        },
    },
}

const mutations = {
    SET_LANGUAGE(state, language) {
        if (state.texts.hasOwnProperty(language)) {
            state.current = language
        }
    },
}

module.exports = {
    state,
    mutations,
}
