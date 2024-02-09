<template>
    <div>
        <span v-if="status == 'pending'" class="badge bg-label-warning" style="text-transform: capitalize;">
            {{ status }}

            <slot name="append"></slot>
        </span>
        <span v-else-if="status == 'progress'" class="badge bg-label-primary" style="text-transform: capitalize;">
            {{ status }}
            
            <slot name="append"></slot>
        </span>
        <span v-else-if="status == 'finish'" class="badge bg-label-success" style="text-transform: capitalize;">
            {{ status }}
            
            <slot name="append"></slot>
        </span>
        <span v-else-if="status == 'cancel'" class="badge bg-label-danger" style="text-transform: capitalize;">
            {{ status }}
            
            <slot name="append"></slot>
        </span>
    </div>
</template>
<script>
export default {
    props: ['status'],
}
</script>