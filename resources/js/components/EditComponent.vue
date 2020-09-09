<template>
    <div>
        <h1>Edit Product</h1>
        <form @submit.prevent="updateProduct">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name:</label>
                        <input type="text" class="form-control" v-model="product.name" :placeholder="product.name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Description:</label>
                        <textarea class="form-control" v-model="product.description" rows="2" :placeholder="product.description"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Price:</label>
                        <input type="number" step="0.01" class="form-control" v-model="product.price" :placeholder="product.price">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Amount:</label>
                        <input type="number" class="form-control" v-model="product.amount" :placeholder="product.amount">
                    </div>
                </div>
            </div><br />
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
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {

    data() {
        return {
            errors:[],
            product: {},
        }
    },
    created() {
        let uri = `http://localhost:8000/api/products/${this.$route.params.id}`;
        this.axios.get(uri).then((response) => {
            console.log(response);
            this.product = response.data;
        });
    },
    methods: {
        updateProduct() {
            console.log(this.product);
            this.errors = [];
            if(this.validateForm()) {
                let uri = `http://localhost:8000/api/products/${this.$route.params.id}`;
                this.axios.put(uri, this.product).then((response) => {
                    this.$router.push({name: 'products'});
                });
            }
        },
        validateForm(){

            if(this.product.name === ''){
                this.errors.push('Invalid name');
            }
            if(this.product.description === ''){
                this.errors.push('Invalid description');
            }
            if(this.product.amount === ''){
                this.errors.push('Invalid amount');
            }
            if(this.product.amount > 99999){
                this.errors.push('Amount is too high!');
            }
            if(this.product.price === ''){
                this.errors.push('Invalid price');
            }
            if(this.product.price > 99999){
                this.errors.push('Price is too high!');
            }
            return this.errors.length <= 1;
        }
    }
}
</script>
