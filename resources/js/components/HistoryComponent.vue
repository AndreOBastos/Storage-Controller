<template>
    <div>
        <h1>History</h1>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Product ID</th>
                <th>Change Description</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="change in history" :key="change.id">
                <td>{{ change.id }}</td>
                <td>{{ change.product_id }}</td>
                <td>{{ change.change_description }}</td>
                <td>{{ change.created_at | formatDate}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    data() {
        return {
            history: []
        }
    },
    created() {
        let uri = 'http://localhost:8000/api/products_history';
        this.axios.get(uri).then(response => {
            this.history = response.data.data;
        });
    },
    filters: {
        formatDate: function(value) {
            if (value) {
                return moment(String(value)).format('hh:mm MM/DD/YYYY')
            }
        }
    }
}
</script>
