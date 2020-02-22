<template>
    <div class="dropdown ">
       <div class="dropdown-toggle" @click.prevent="isOpen = !isOpen" >
           <slot name="trigger"></slot>
       </div>
        <div class="dropdown-menu py-3 mt-2 absolute  dropdown-item card " v-show="isOpen" :class="align === 'left' ? 'left-auto' : 'right-auto' " :style="{width}">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            width: {default: 'auto'},
            align: {default: 'left'}
        },
        data() {
            return {
                isOpen:false
            }
        }
    }
</script>
