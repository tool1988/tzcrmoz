<template>
    <div class="max-w-lg mx-auto p-4">
        <p class="error text-red-500" v-if="error">{{ error }}</p>
        <p class="success text-green-500" v-if="message">{{ message }}</p>
        <h3 class="text-2xl font-semibold mb-4">Create Account</h3>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name:</label>
                <input type="text" v-model="form.account_name" id="account_name" name="account_name"
                       :class="{'border-red-500': errors.account_name, 'border-gray-300': !errors.account_name}"
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required />
                <span v-if="errors.account_name" class="text-sm text-red-500">{{ errors.account_name }}</span>
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700">Website:</label>
                <input type="text" v-model="form.website" id="website" name="website"
                       :class="{'border-red-500': errors.website, 'border-gray-300': !errors.website}"
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required />
                <span v-if="errors.website" class="text-sm text-red-500">{{ errors.website }}</span>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                <input type="text" v-model="form.phone" id="phone" name="phone"
                       :class="{'border-red-500': errors.phone, 'border-gray-300': !errors.phone}"
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required />
                <span v-if="errors.phone" class="text-sm text-red-500">{{ errors.phone }}</span>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-500 ring-blue-500 text-black font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Create</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
//axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
export default {
    data() {
        return {
            message: '',
            error: '',
            form: {
                account_name: '',
                website: '',
                phone: '',
            },
            errors: {
                account_name: null,
                website: null,
                phone: null,
            }
        };
    },
    methods: {
        async submitForm() {
            this.errors = {
                account_name: null,
                website: null,
                phone: null,
            };
            this.message = '';
            this.error = '';
            let isValid = true;

            if (this.form.account_name.length < 3) {
                this.errors.account_name = 'Must be at least 3 characters long';
                isValid = false;
            }

            if (this.form.account_name.length > 100) {
                this.errors.account_name = 'Must be no more than 100 characters';
                isValid = false;
            }

            if (this.form.website.length < 3) {
                this.errors.website = 'Must be at least 3 characters long';
                isValid = false;
            }

            if (this.form.website.length > 100) {
                this.errors.website = 'Must be no more than 100 characters';
                isValid = false;
            }

            if (!this.validatePhone(this.form.phone)) {
                this.errors.phone = 'Incorrect phone';
                isValid = false;
            }

            if (!this.validateWebsite(this.form.website)) {
                this.errors.website = 'Incorrect website';
                isValid = false;
            }
            if (isValid) {
                try {
                    const response = await axios.post('/account', {
                        account_name: this.form.account_name,
                        website: this.form.website,
                        phone: this.form.phone,
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
                    account_name: '',
                    website: '',
                    phone: ''
                };
            }
        },
        validatePhone(phone) {
            const phoneRegex = /^(\+?[0-9]{1,3})?[-.\s]?\(?\d{1,3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/;
            return phoneRegex.test(phone);
        },

        validateWebsite(website) {
            const websiteRegex = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}(\/[a-zA-Z0-9-]*)*$/;
            return websiteRegex.test(website);
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
