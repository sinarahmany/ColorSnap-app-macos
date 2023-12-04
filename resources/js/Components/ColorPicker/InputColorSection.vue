<script setup>
import TextInput from "@/Components/TextInput.vue";
import {ref, defineProps, defineEmits} from "vue";
import CopyToClipboard from "@/Components/ColorPicker/CopyToClipboard.vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
});

const emit = defineEmits();

const handleChange = (newValue) => {
    emit('update:modelValue', newValue);
}

const handleInput = (newValue) => {
    emit('input', newValue); // Custom input event
}
</script>

<template>
    <div>
        <div class="flex justify-between items-center my-2">
            <label class="label select-none">{{ props.label }}:</label>
            <div class="control">
                <div
                    class="flex items-center justify-between relative">
                    <TextInput
                        :modelValue="props.modelValue"
                        @update:modelValue="handleChange"
                        @input="handleInput"
                    />
                    <CopyToClipboard :text="props.modelValue" />
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
.st0 {
    fill-rule: evenodd;
    clip-rule: evenodd;
}
</style>
