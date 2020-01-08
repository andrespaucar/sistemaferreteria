<template>
<div> 
  <h2>thi is COMPONENT DE VUE1a :)</h2>
  <p>Lor quo nte accusantigrsgsrgsrgrsriores cupiditate, delectus dicta!</p>
</div>
</template>

<script>
export default {
    mounted(){
        console.log('Componente mounted ');
        axios
          .get('https://api.coindesk.com/v1/bpi/currentprice.json')
          .then(response => (console.log(response)))
    }
}
</script>
