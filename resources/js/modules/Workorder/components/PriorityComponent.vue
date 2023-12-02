<template>
    <div>
        <span v-if="status == 'medium'" class="badge bg-label-warning" style="text-transform: capitalize;">{{ status }}</span>
        <span v-else-if="status == 'high'" class="badge bg-label-danger" style="text-transform: capitalize;">{{ status }}</span>
        <span v-else-if="status == 'low'" class="badge bg-label-success" style="text-transform: capitalize;">{{ status }}</span>
    </div>
</template>
<script>
export default {
    props: ['status'],
}
</script>