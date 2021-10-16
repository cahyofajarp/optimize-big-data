<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div v-if="loader" class="loader">
               Loading ... 
            </div>

            <form>
              <div class="form-group">
                <input type="text" v-model="search" class="form-control" placeholder="Search ...">
            </div>
            
            </form>
            <div v-if="loader2" class="text-center">
              <div class="p-3">Sedang mencari ...</div>
            </div>
            <div v-if="employees.length < 1" class="mb-2">
                <span>Tidak ada data :  <b>{{ this.search }}</b></span>
            </div>
            
              
                <table class="table table-striped table-hover d-table">
                    <thead class="" style="background:#3f51b5;color:white">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Last Education</th>
                        </tr>
                    </thead>
                    <tbody v-if="employees.length > 0">
                        <tr  v-for="(employee,index) in employees" :key="index" >
                          <td>{{ no + (index + 1) }}</td>
                          <td>{{ employee.name }}</td>
                          <td>{{ employee.tanggal_lahir }}</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td colspan="3">No data availbale.</td>
                      </tr>
                    </tbody>
                </table>

                <div class="pagination">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                          <li class="page-item">
                            <a class="page-link" href="" @click.prevent="prev()" aria-label="Previous">
                              <span aria-hidden="true">&laquo;</span>
                              <span class="sr-only">Previous</span>
                            </a>
                          </li>
                          
                          <li class="page-item"   
                          v-for="(lim,index) in pagingNumber" :key="index"  
                      
                          v-bind:class="[(index + 1) + changeNumber ==  setActive ? 'active' : '']">
                          
                          <a class="page-link" 
                          
                          @click.prevent="paginate((index + 1) + changeNumber)"
                          
                          href="">{{ (index + 1) + changeNumber }}</a></li>
                          
                          <li class="page-item">
                            <a class="page-link" href="" @click.prevent="next()" aria-label="Next">
                              <span aria-hidden="true">&raquo;</span>
                              <span class="sr-only">Next</span>
                            </a>
                          </li>
                        </ul>
                      </nav>
                </div>
          
                <div class="found-data-table">
                    <div>Showing {{ dataShowPagi > 0 ? no + 1 : no  }} to {{ no + max }} of {{ dataShowPagi }} entries</div>
                </div>
        </div>
    </div>
</div>
</template>

<script>


export default {
  data () { 
    return {
      employees : [],
      limit : 0,
      pagingNumber : 0,
      countPaging : 0,
      changeNumber : 0,
      loader:false,
      page : 0,
      setActive : 0,
      nextP :1,
      prevP: 1,
      //---------
      search: '',
      loader2: false,
      dataShowPagi: 0,
      no:0,
      max:0,
      
    }
  },
  
  methods : {
      async fetchData() {

         const res =  await axios.get(`http://127.0.0.1:8000/show-employee`);
         
         this.employees = await  res.data.employees;

          this.limit =  await res.data.limit;

          //-----------------
          
          this.max  = res.data.max;
          
          
          const pn = await res.data.count;

          this.dataShowPagi = pn;

          this.pagingNumber = await Math.floor(res.data.count / this.limit);

          this.countPaging = await Math.floor(res.data.count / this.limit);

          if(this.employees.length > 0){
            this.setActive = 1;
          }

          if(pn % this.limit != 0){
            let data = Math.floor(this.pagingNumber);
            
            data += 1;

            this.countPaging = data;
            this.pagingNumber = data;

          }

          if(this.pagingNumber >= this.limit){
            this.pagingNumber = this.limit;
          }


      },
            
      async paginate(limit) {
        const lim = this.limit;
        // LOGIC SHOW DATA WITH LIMIT

        this.page = (limit - 1) * lim;
      

        this.nextP = limit;

        this.prevP = limit;

        this.loader = true;

        const res = await axios.post(`http://127.0.0.1:8000/show-employee/search`,{
              page : this.page,
              data : this.search
          });
        
        this.no = this.page;

        this.max  = await res.data.max;
          
        
        console.log(this.max);

        this.loader = false;

        this.employees = await res.data.employees;
      
        this.limit = await res.data.limit;
        // -------------------------------------------------

          // set Active PAGINATION
          
          if(limit){
              this.setActive = limit;
          }

        // -------------------------------------------------

        // Logic Change pagination Number
        const lastData = limit;

        if(lastData >= this.limit + this.changeNumber && limit != this.countPaging){
            this.changeNumber += 1;
        }
        else if(limit != 1){
          if(limit == (this.limit + this.changeNumber) - (this.limit - 1)){
            this.changeNumber -= 1;
          }
        }

        // --------------------------------------------------------
  
      },
      
      async next(){
        
        const lim = this.limit;
        
        this.nextP += 1;

        if(this.nextP <= this.countPaging){
          
        // LOGIC SHOW DATA WITH LIMIT
        this.page = (this.nextP - 1) * lim;

        this.prevP = this.nextP;

        const lastData = this.nextP;

        this.loader = true;

          const res = await axios.post(`http://127.0.0.1:8000/show-employee/search`,{
              page : this.page,
              data : this.search
          });

          this.max = await res.data.max;
          
          this.employees = await res.data.employees;

          this.limit = await res.data.limit;
          
          this.no = this.page;

          this.loader = false;

          // set Active 
          if(this.page){
            this.setActive = this.nextP;
          }
          if(lastData >= this.limit + this.changeNumber && lastData != this.countPaging && this.countPaging > lastData){
            this.changeNumber += 1;
          }
        }
        else{
          alert('sudah di akhir page!');
        }
      },

      async prev(){

        const lim = this.limit;

          this.prevP -= 1;
        

        if(this.prevP >= 1){
          
          this.page = (this.prevP - 1) * lim;
          
          this.nextP = this.prevP;

          if(this.prevP == (this.limit + this.changeNumber) - (this.limit - 1) && this.changeNumber != 0){
            this.changeNumber -= 1;
          }

          this.loader = true;

          const res = await axios.post(`http://127.0.0.1:8000/show-employee/search`,{
            page : this.page,
            data : this.search
          });
          
          this.no = this.page;

          this.max = await res.data.max;
          
          this.employees = await res.data.employees;
        
          this.limit = await res.data.limit;

          this.loader = false;

          this.setActive = this.prevP;
        }
        else {
          alert('Opps maaf sudah di page awal');
        }
      },

  },
 
  watch :{
    search : async function() {

        this.loader2 = true;
        
        const res = await axios.post(`http://127.0.0.1:8000/show-employee/search`,{
            data : this.search
        });

        this.employees = await res.data.employees;
        
        this.max = await res.data.max;
        
        this.no = 0;

        this.page = 0;

        this.loader2 = false;
        
        this.pagingNumber = await res.data.count;
        
        this.dataShowPagi = await res.data.count;        
        
        this.countPaging = this.pagingNumber / this.limit;

        this.nextP = 1;

        if(this.employees.length > 0){
          
          this.setActive = 1;
          this.changeNumber = 0;
        }


        if(this.pagingNumber % this.limit != 0){
          
          let data = Math.floor(this.pagingNumber / this.limit);
          
          data += 1;

          this.countPaging = data;
          
          this.pagingNumber = data;

        }

        if(this.pagingNumber > this.limit){

          this.pagingNumber = this.limit;
        }
    }
  },
  created() {
    this.fetchData();
   
  },
  mounted(){

  },
}
</script>

<style scoped>
.loader{
  text-align: center;
    position: fixed;
    margin: 0 auto;
    top: 50%;
    background: white;
    left: 50%;
}
</style>

