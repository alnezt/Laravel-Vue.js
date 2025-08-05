<template>
    <div class="talon">
        <TalonOCR/>
    </div>
    <div class="container">
 <h1>Oferte asigurari</h1>

        <AsigurariRCA />  <!-- 👈 Folosește numele corect al componentei -->

    </div>


</template>

<script setup>
import AsigurariRCA from './components/AsigurariRCA.vue'  // 👈 Cale corectă
import TalonOCR from './components/TalonOCR.vue';
</script>

<style scoped>
.container {
    max-width: 700px;
    margin: 3rem auto;
    padding: 1rem;
    text-align: center;
    font-family: Arial, sans-serif;
}

.talon{
    max-width: 700px;
    margin: 3rem auto;
    padding: 1rem;
    text-align: center;
    font-family: Arial, sans-serif;
}
</style>
