<template>
    <div>
        <toolbar></toolbar>
        <router-view/>
        <app-footer></app-footer>
    </div>
</template>

<script>

import toolbar from "./toolbar";
import AppFooter from "./AppFooter";
import Login from "./login/Login";
export default {
    components:{toolbar , AppFooter , Login }
}


</script>

<style>

</style>
