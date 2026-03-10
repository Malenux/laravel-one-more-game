import { createSlice } from "@reduxjs/toolkit";

export const crudSlice = createSlice({
    name: "crud",
    initialState: {
        form: null,
        table: null,
        overlayActive: false,
        deleteModal: {
            active: false,
            endpoint: null,
            elementId: null
        },
        filterModal: {
            active: false,
            endpoint: null,
            params: {}
        },
        message: {
            text: null,
            type: null
        }
    },
    reducers: {
        setForm: (state, action) => {
            state.form = action.payload;
        },
        setTable: (state, action) => {
            state.table = action.payload;
        },
        setDeleteModal: (state, action) => {
            state.deleteModal = { ...state.deleteModal, ...action.payload };
            state.overlayActive = action.payload.active ?? state.overlayActive;
        }, setFilterModal: (state, action) => {
            state.filterModal = { ...state.filterModal, ...action.payload };
            state.overlayActive = action.payload.active ?? state.overlayActive;
        },
        setMessage: (state, action) => {
            state.message = action.payload;
        }
    },
});

export const { setForm, setTable, setDeleteModal, setFilterModal, setMessage } = crudSlice.actions;
export default crudSlice.reducer;
