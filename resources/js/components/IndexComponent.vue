<template>
    <div>
        <h1>Products</h1>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <router-link :to="{ name: 'create' }" class="btn btn-primary">Store New Product</router-link>
            </div>
        </div><br />

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.amount }}</td>
                <td><router-link :to="{name: 'edit', params: { id: product.id }}" class="btn btn-primary">Edit</router-link></td>
                <td><button class="btn btn-danger" @click.prevent="deleteProduct(product.id)">Delete</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: []
        }
    },
    created() {
        let uri = 'http://localhost:8000/api/products';
        this.axios.get(uri).then(response => {
            this.products = response.data.data;
        });
    },
    methods: {
        deleteProduct(id)
        {
            let uri = `http://localhost:8000/api/products/${id}`;
            this.axios.delete(uri).then(response => {
                var elementPos = this.products.map(function(x) {return x.id; }).indexOf(id);
                this.products.splice(elementPos, 1);
            });
        }
    }
}
</script>

