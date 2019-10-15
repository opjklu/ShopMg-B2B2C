/**
 *  标识
 */
const state = {

    record_number: '',
    logo: '',
    intnet_licence: '',
    intnet_copyright: '',
    init_qr_code: '',
    intnet_phone: ''
}

const mutations = {
    SET_RECORD_NUMBER: (state, token) => {
        state.record_number = token
    },
    SET_IINTNET_LICENCE: (state, introduction) => {
        state.intnet_licence = introduction
    },
    SET_INTNET_COPYRIGHT: (state, name) => {
        state.intnet_copyright = name
    },
    SET_LOGO: (state, avatar) => {
        state.logo = avatar
    },
    SET_INIT_QR_CODE: (state, init_qr_code) => {
        state.init_qr_code = init_qr_code
    },
    SET_INTNET_PHONE: (state, intnet_phone) => {
        state.intnet_phone = intnet_phone
    },

}

const actions = {
    setRecordNumber({ commit }, record_number) {
        commit('SET_RECORD_NUMBER', record_number)
    },

    setLogo({ commit }, data) {
        commit('SET_LOGO', data)
    },

    setLicence({ commit }, record_number) {
        commit('SET_IINTNET_LICENCE', record_number)
    },

    setCopyright({ commit }, data) {
        commit('SET_INTNET_COPYRIGHT', data)
    },

    setQrcode({ commit }, record_number) {
        commit('SET_INIT_QR_CODE', record_number)
    },

    setTelphone({ commit }, data) {
        commit('SET_INTNET_PHONE', data)
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
