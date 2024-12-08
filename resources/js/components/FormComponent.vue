<template>
    <div>
        <form @submit.prevent="submitForm">
            <div>
                <label for="field1">Поле 1:</label>
                <input type="text" v-model="field1" id="field1" />
            </div>
            <div>
                <label for="field2">Поле 2:</label>
                <input type="text" v-model="field2" id="field2" />
            </div>
            <button type="submit">Отправить</button>
        </form>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            field1: '',
            field2: '',
            message: ''
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await axios.post('/api/submit-form', {
                    field1: this.field1,
                    field2: this.field2
                });

                if (response.data.success) {
                    this.message = 'Форма успешно отправлена!';
                }
            } catch (error) {
                this.message = 'Ошибка при отправке формы!';
            }
        }
    }
};
</script>
