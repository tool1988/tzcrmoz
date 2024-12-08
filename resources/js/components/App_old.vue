<template>
    <div class="flex space-x-4">
        <div class="bg-blue-200 p-4 flex-1">
            <AccountForm />
        </div>
        <div class="bg-green-200 p-4 flex-1">
            <DealForm />
        </div>
    </div>
</template>

<script>
import AccountForm from './AccountForm.vue';
import DealForm from './DealForm.vue';

export default {
    components: {
        AccountForm,
        DealForm
    }
};
</script>
