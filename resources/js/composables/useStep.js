import { ref } from 'vue'
export default () => {
    const step = ref(1)
    const nextStep = () => {
        if (step.value < 2) step.value++
    }
    const prevStep = () => {
        if (step.value > 1) step.value--
    }
    return {
        step,
        nextStep,
        prevStep
    }
}
