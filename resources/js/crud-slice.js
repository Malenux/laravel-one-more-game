import { createSlice } from "@reduxjs/toolkit";

export const crudSlice = createSlice({
    name: "crud",
    initialState: {
        form: null,
        table: null,
        deleteModal: {
            active: false,
            endpoint: null,
            elementId: null
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
        },
        setMessage: (state, action) => {
            state.message = action.payload;
        }
    },
});

export const { setForm, setTable, setDeleteModal, setMessage } = crudSlice.actions;
export default crudSlice.reducer;
