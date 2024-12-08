<template>
    <div class="max-w-lg mx-auto p-4">
        <p class="error text-red-500" v-if="error">{{ error }}</p>
        <p class="success text-green-500" v-if="message">{{ message }}</p>
        <h3 class="text-2xl font-semibold mb-4">Create Deal</h3>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="account_name" class="block text-sm font-medium text-gray-700">Deal Name:</label>
                <input type="text" v-model="form.deal_name" id="deal_name" name="deal_name"
                       :class="{'border-red-500': errors.deal_name, 'border-gray-300': !errors.deal_name}"
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required />
                <span v-if="errors.deal_name" class="text-sm text-red-500">{{ errors.deal_name }}</span>
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700">Deal Stage:</label>
                <input type="text" v-model="form.deal_stage" id="website" name="deal_stage"
                       :class="{'border-red-500': errors.deal_stage, 'border-gray-300': !errors.deal_stage}"
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required />
                <span v-if="errors.deal_stage" class="text-sm text-red-500">{{ errors.deal_stage }}</span>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 ring-blue-500 text-black font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Create</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            message: '',
            error: '',
            form: {
                deal_name: '',
                deal_stage: '',
            },
            errors: {
                deal_name: null,
                deal_stage: null,
            }
        };
    },
    methods: {
        async submitForm() {
            this.errors = {
                deal_name: null,
                deal_stage: null,

            };
            this.message = '';
            this.error = '';
            let isValid = true;

            if (this.form.deal_name.length < 3) {
                this.errors.deal_name = 'Must be at least 3 characters long';
                isValid = false;
            }

            if (this.form.deal_name.length > 100) {
                this.errors.deal_name = 'Must be no more than 100 characters';
                isValid = false;
            }

            if (this.form.deal_stage.length < 3) {
                this.errors.deal_stage = 'Must be at least 3 characters long';
                isValid = false;
            }

            if (this.form.deal_stage.length > 100) {
                this.errors.deal_stage = 'Must be no more than 100 characters';
                isValid = false;
            }

            if (isValid) {
                try {
                    const response = await axios.post('/deal', {
                        deal_name: this.form.deal_name,
                        deal_stage: this.form.deal_stage
                    });

                    if (response.data.status == 'error') {
                        this.error = response.data.message;
                    } else {
                        this.message = response.data.message;
                    }

                } catch (error) {
                    this.error = 'Error!';
                }
                this.form = {
                    deal_name: '',
                    deal_stage: '',
                };
            }
        }
    }
};
</script>

<style scoped>
.error {
    color: red;
}
.success {
    color: green;
}
.is-invalid {
    border: 1px solid red;
}
</style>
