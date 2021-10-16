<template>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" v-model="searchBy" class="form-control" placeholder="Search data in here ...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody v-if="employees.length > 0">
                                <tr v-for="(employee,index) in employees" :key="index">
                                    <td>{{ offsetNumberPaginate + 1 + index }}</td>
                                    <td>{{ employee.name }}</td>
                                    <td>{{ employee.tanggal_lahir }}</td>
                                    <td><button class="btn btn-sm btn-danger" @click.prevent="fDelete(employee)">Delete</button></td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr>
                                    <td class="text-center" colspan="3" style="
                background: #f8fafc;
                border-radius: 100px;">No data.</td>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>
            
           
            <nav aria-label="Page navigation example mt-2">
                <ul class="pagination">
                    
                    <li class="page-item">
                    <a class="page-link" @click.prevent="setPage(currentPageIndex - 1)" href="" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                    </li>
                    
                    <li class="page-item" 
                        :class="{ 'active' : currentPageIndex === index + changeNumber }" v-for="(i,index) in setLimitPages" :key="index">
                        <a class="page-link" @click.prevent="setPage(index + changeNumber)" href="">{{ index + changeNumber}}</a></li>
                    
                    <li class="page-item">
                    <a class="page-link" @click.prevent="setPage(currentPageIndex + 1)" href="" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                    </li>
                </ul>
            </nav>
            
            <div class="found-data-table">
                <div>Showing {{ cdEmployees > 0 ? offsetNumberPaginate + 1 : 0 }} to {{ offsetNumberPaginate + max }} of {{ cdEmployees  }} entries</div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            employees: [], // Data Employees
            limit : 0, // limit per Page getting from axios API
            cdEmployees : 0, // count data employee
            currentPageIndex : 1, // current page active,
            currentPage : 1, // current page
            setLimitOnPage : 0, // set limit pagination 
            changeNumber : 1, // change number on pagination if index > limit
            loader : false,
            offsetNumberPaginate : 0,
            searchBy : '', // search
            max : 0, // maximal data per Page if at last there are 8 of 10 data before , so we can print 8 
            
        }
    },
    methods : {
        async getEmployee(){
            const res =  await axios.get(`http://127.0.0.1:8000/show-employee`);
            this.employees = await res.data.employees; // get data employees
            this.cdEmployees = await res.data.count; // get count employee
            this.limit = await res.data.limit; // get limit 
            this.max = await res.data.max; // get max

        },
        
        async setPage(page){
            
            if(page < 1){
                alert('Oops sudah di awal page'); // 
            }else if(page > this.pages){
                alert('sudah di akhir halaman');
            }
            
            if(this.pages >= page && page >= 1){

                this.currentPage = page;
                
                // console.log(this.);
                this.loader = true; // set Active loader
                
                const res = await axios.post(`http://127.0.0.1:8000/show-employee/search`,{
                    page : this.offset, // offset data getting data from offset function on computed in below
                    data : this.searchBy // if there are a search value else null and show all data in index
                });

                this.offsetNumberPaginate = this.offset;

                this.max = await res.data.max;
                
                this.employees = await res.data.employees; // set Employee with offset data { this.offset in computed function }
                
                this.loader = false; // set Non Active loader

                this.currentPageIndex = page; // set Active Pagination
                
                
                if(page >= this.setLimitPages && this.pages > page  && (this.setLimitPages - 1) + this.changeNumber == page ){
                    this.changeNumber += 1; // change index number on pagination
                }
                
                else if(this.changeNumber > 1){
                    if(page == this.changeNumber){
                        this.changeNumber -= 1; // - 1 if page == changeNumber 
                    }
                }
            }

        },

        fDelete(id){
            // let data = this.employees.indexOf(id);

            // console.log(data);
            this.employees.splice(this.employees.indexOf(id),1);
            
        }
    },
    computed :{
        pages : function(){
            
            const cdEmployees = this.cdEmployees;
            let count = Math.ceil(cdEmployees / this.limit);

            return this.employees.length > 0 ? count : 0 ; // if count employees greather than 0 and than write count if not print 0
        },
        
        offset : function() {
            
            let offsetPagination = (this.currentPage - 1) * this.limit;
            
            return offsetPagination;
        },

        setLimitPages : function() { // set Limit in paginate with 10 page first and will continue until this.employees.length page 
           
           const limPage = 10; // configuration set perpage on index , default is 5 
           
           const cdEmployees = this.cdEmployees
            this.setLimitOnPage = Math.ceil(cdEmployees / this.limit);

            // console.log(count)
            if(this.setLimitOnPage >= limPage){
                this.setLimitOnPage = limPage; 
            } 
            
            return this.setLimitOnPage > 0 ? this.setLimitOnPage : 0;
        },

    },
    created(){
        this.getEmployee();
    },

    watch : {
        searchBy : async function() {

            const res = await axios.post(`http://127.0.0.1:8000/show-employee/search`,{
                data : this.searchBy
            });
            
            this.employees = await res.data.employees;
            this.cdEmployees = await res.data.count;
            this.limit = await res.data.limit;
            this.max = await res.data.max;

            this.currentPageIndex = 1;
            this.changeNumber = 1;
            // this.max = 0; 
            this.currentPage = 1; // current page
            this.offsetNumberPaginate = 0;
        }
    }
}
</script>

<style>

</style>