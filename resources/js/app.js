/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import 'admin-lte/dist/js/adminlte.min';

import { createApp } from 'vue'
import { createStore } from 'vuex'


import { createWebHistory, createRouter } from "vue-router";

import {routes} from './routes';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp({
});

import EmployeeList from "./components/Employees/EmployeeList";
import MainAdminPanel from "./components/MainAdminPanel";
import Errors from "./components/Errors";

app.component('employee-list', EmployeeList)
app.component('main-admin-panel', MainAdminPanel)
app.component('errors', Errors)

import Vue3Datepicker from 'vue3-datepicker';
app.component('Vue3Datepicker', Vue3Datepicker)

import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
app.component('VueBootstrapTypeahead', VueBootstrapTypeahead)

app.use(router);




//vuex
const employeeModule = {
    namespaced:true,
    state(){
        return{
            form:{
                name: '',
                photo: '',
                email: '',
                phone: '',
                position: '',
                boss: '',
                boss_id: 0,
                date_start_work:new Date(),
                salary: 0,
                image : null
            },
            editId:0,
            currentImage:null,
            employees:[]
        }
    },
    mutations:{
        setImage(state,payload){
            state.form.image = payload;
        },

        setEmployees(state,payload){
            state.employees = payload;
        },

        setBoss(state,payload){
            state.form.boss = payload;
        } ,
        setBossId(state,payload){
            state.form.boss_id = payload;
        },

        setId(state,payload){
            state.editId = payload;
        },


    },
    actions:{

        deleteEmployee(context,payload){
            const path = route('employeeapi.destroy', payload);
            axios.delete(path).then(response=>{
            }).catch(error=>{
                console.log(error);
            })
        },

        async getEmployees(context,payload){
           await axios.get('/employeeapi')
                .then((response)=>{

                    context.commit('setEmployees',response.data.data);

                    const employees = response.data.data;
                    if ($.fn.DataTable.isDataTable('#employeesTable') ) {
                        $('#employeesTable').DataTable().destroy();
                    }
                    $('#employeesTable tbody').empty();

                    $('#employeesTable').DataTable({
                        data: employees,
                        columns: [
                            { data: 'image', render: function (data) {
                                    if (data !== '') {
                                        return '<img style="height: 60px;border-radius: 30px;" src="' + data + '">';
                                    }
                                }},
                            { data: 'name', name: 'name' },
                            { data: 'email', name: 'email' },
                            { data: 'phone', name: 'phone' },
                            { data: 'position', name: 'position' },
                            { data: 'date_start_work', name: 'date_start_work' },
                            { data: 'salary', name: 'salary' },
                            { data: 'action', name: 'action' },
                        ]
                    });


                });
        },


        getEmployee({context,state},payload){
            axios.get('/employeeapi/'+state.editId).then(response=>{

                const dataEl = response.data.data;
                state.form.name = dataEl.name;
                state.form.email = dataEl.email;
                state.form.phone = dataEl.phone;

                state.form.position = dataEl.position_id;
                state.form.boss = dataEl.boss_name;
                state.currentImage = dataEl.image;
                state.form.boss_id = dataEl.boss_id;
                console.log(dataEl.date_start_work);
                /* this.form.date_start_work = parseISO(dataEl.date_start_work);*/

                const dateStr = dataEl.date_start_work;
                // Split the date string into day, month, and year components
                const dateComponents = dateStr.split('.');
                const day = parseInt(dateComponents[0]);
                const month = parseInt(dateComponents[1]) - 1; // JavaScript months are 0-indexed
                const year = parseInt(dateComponents[2]);
                state.form.date_start_work = new Date(year, month, day);
                state.form.salary = dataEl.salary;


            }).catch(error=>{
                console.log(error)
            })
        },



        autocomplete(context,payload){
            const path = route('autocomplete.employees');
            payload.typeahead({
                updater: function(item) {
                    context.commit('setBoss',item.name);
                    context.commit('setBossId',item.id);
                    return item;
                },
                source: function (query, process) {
                    return $.get(path, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                }
            });


        },

        setImage(context,payload){
            const files = payload.target.files;
            context.commit('setImage',files[0]);
        },

        setId(context,payload){
            context.commit('setId',payload);
        },

        async saveEmployee(context,payload){
            const path = route('employeeapi.store');
            const formData = new FormData();
            Object.keys(payload).forEach(key => {
                if (payload[key] !== null) {
                    formData.append(key,payload[key]);
                }
            });
            await axios.post(path, formData).then(response=>{
                context.dispatch('errors/setErrors', [], { root: true });
            }).catch(error=>{
                if(error.response.status === 422) {
                    console.log('there are errors');

                    context.dispatch('errors/setErrors', error.response.data.errors, { root: true });
                } else {
                    console.log('Unkown error!')
                }
            })
        },

        async updateEmployee(context,payload){
            const { state } = context;
            const path = route('employeeapi.update', state.editId);
            const formData = new FormData();
            Object.keys(state.form).forEach(key => {
                if (state.form[key] !== null) {
                    formData.append(key, state.form[key]);
                }
            });
            const config = {
                headers: {
                    'X-HTTP-Method-Override': 'PUT',
                    'Content-Type': 'multipart/form-data'
                }
            };

            await axios.post(path, formData,config).then(response=>{
                context.dispatch('errors/setErrors', [], { root: true });
            }).catch(error=>{
                if(error.response.status === 422) {
                    context.dispatch('errors/setErrors', error.response.data.errors, { root: true });
                } else {
                    console.log('Unkown error!')
                }
            });
        }
    },

    getters:{

        form(state){
            return state.form;
        },

        editId(state){
            return state.editId;
        },
        currentImage(state){
            return state.currentImage;
        },

    }
};


const positionModule = {
    namespaced:true,
    state() {
        return{
            positions:[],
            form:{
                name: '',
            },
            editId:0
        }
    },
    mutations:{
        setPositions(state,payload){
            state.positions = payload;
        },
        setId(state,payload){
            state.editId = payload;
        }
    },
    actions:{
        setId(context, payload){
            context.commit('setId',payload);
        },

        getPositions(context, payload){
            axios.get('/allPositions')
                .then(response=>{
                    context.commit('setPositions',response.data.data);
                }).catch(error => {
                console.error(error);
            });
        },

        async savePosition(context, payload){
            const path = route('positionapi.store');
            await axios.post(path, payload).then(response=>{
                context.dispatch('errors/setErrors', [], { root: true });
            }).catch(error=>{
                if(error.response.status === 422) {
                    context.dispatch('errors/setErrors',error.response.data.errors, { root: true });
                } else {
                    console.log('Unkown error!')
                }
            })
        },

        getPosition({context,state}, payload){
            axios.get('/positionapi/'+state.editId).then(response=>{
                const dataEl = response.data.data;
                state.form.name = dataEl.name;
                console.log('state.form.name='+state.form.name);

            }).catch(error=>{
                console.log(error)
            })
        },

        async deletePosition(context,payload){
            const path = route('positionapi.destroy', payload);
            await axios.delete(path).then(response=>{

            }).catch(error=>{
                console.log(error);
            })
        },

        async getPositionsList(context,payload){
           await axios.get('/positionapi')
                .then((response)=>{
                    context.commit('setPositions',response.data.data);

                    const positions = response.data.data;

                    if ($.fn.DataTable.isDataTable('#positionsTable') ) {
                        $('#positionsTable').DataTable().destroy();
                    }

                    $('#positionsTable tbody').empty();

                    $('#positionsTable').DataTable({
                        data: positions,
                        columns: [
                            { data: 'name', name: 'name' },
                            { data: 'updated_at', name: 'updated_at' },
                            { data: 'action', name: 'action' },
                        ]
                    });
                });
        },

        async updatePosition(context, payload){

            const { state } = context;

            const path = route('positionapi.update', state.editId);
            const config = {
                headers: {
                    'X-HTTP-Method-Override': 'PUT',
                }
            };

            await axios.post(path, state.form,config).then(response=>{
                context.dispatch('errors/setErrors', [], { root: true });
            }).catch(error=>{
                console.log('error='+error);
                if(error.response.status === 422) {
                    context.dispatch('errors/setErrors', error.response.data.errors, { root: true });
                } else {
                    console.log('Unkown error!')
                }
            });


        },



    },
    getters:{
        positions(state){
            return state.positions;
        },

        form(state){
            return state.form;
        },

    }
};

const errorsModule = {
    namespaced:true,
    state() {
        return{
            errors:[]
        }

    },
    mutations:{
        setErrors(state,payload){
            state.errors = payload;
        }
    },
    actions:{
        setErrors(context, payload){
            context.commit('setErrors',payload);
        }
    },
    getters:{
        errors(state){
            return state.errors;
        },

        hasErrors(state){
            const keys = Object.keys(state.errors);
            return keys.length > 0;
        },


    }
};




const store = createStore({
    modules:{
        employees:employeeModule,
        positions:positionModule,
        errors:errorsModule,
    }
})


app.use(store);

app.mount('#app');

