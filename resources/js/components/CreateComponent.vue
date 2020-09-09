<template>
    <div>
        <h1>Store a New Product</h1>
        <form @submit.prevent="addProduct">
            <div v-for="(product, counter) in total_products" v-bind:key="counter">
                <div class="row" v-if="counter!=0">
                    <button type="button" class="close" aria-label="Close">
                        <span @click="deleteProduct(counter)" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Name:</label>
                            <input type="text" class="form-control" v-model="product.name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Description:</label>
                            <textarea class="form-control" v-model="product.description" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Price:</label>
                            <input type="number"  step="0.01" class="form-control" v-model="product.price">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Amount:</label>
                            <input type="number" class="form-control" v-model="product.amount">
                        </div>
                    </div>
                </div>
            </div><br />
        </form>
        <div v-if="errors.length">
            <b>Please, correct the following errors:</b>
            <ul>
                <li v-for="error in errors">
                    <div :id="'warn-' + counter" class="alert alert-danger" >
                        {{ error }}
                    </div>
                </li>
            </ul>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" @click="expandForm">Add one more product</button>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" @click="addProduct">Create</button>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            errors:[],
            total_products:[
                {
                    name:'',
                    description:'',
                    amount:'',
                    price:'',
                }
            ],
        }
    },
    methods: {
        addProduct(){
            this.errors = [];
            if(this.validateForm()){
                if(this.total_products.length === 1){
                    let product = this.total_products[0];
                    let uri = 'http://localhost:8000/api/products';
                    this.axios.post(uri, product).then((response) => {
                        this.$router.push({name: 'products'});
                    });
                } else {
                    let products = {
                        values:this.total_products,
                    };
                    console.log(products);
                    let uri = 'http://localhost:8000/api/many_products'
                    this.axios.post(uri, products).then((response) => {
                        this.$router.push({name: 'products'});
                    });
                }
            }
        },
        expandForm(){
            this.total_products.push({
                name:'',
                description:'',
                amount:'',
                price:'',
            });
            console.log(this.total_products);
        },
        deleteProduct(counter){
            this.total_products.splice(counter,1);
            console.log(this.total_products);
        },
        validateForm(){
            for(let i =0; i<this.total_products.length; i++){
                if(this.total_products[i].name === ''){
                    this.errors.push('Invalid name in product ' + (i+1));
                }
                if(this.total_products[i].description === ''){
                    this.errors.push('Invalid description in product ' + (i+1));
                }
                if(this.total_products[i].amount === ''){
                    this.errors.push('Invalid amount in product ' + (i+1));
                }
                if(this.total_products[i].amount > 99999){
                    this.errors.push('Amount of product ' + (i+1) + ' is too high!');
                }
                if(this.total_products[i].price === ''){
                    this.errors.push('Invalid price in product ' + (i+1));
                }
                if(this.total_products[i].price > 99999){
                    this.errors.push('Price of product ' + (i+1) + ' is too high!');
                }
            }
            return this.errors.length <= 1;
        }
    }
}
</script>
