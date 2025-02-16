<template>
  <v-card class="pa-4">
    <v-card-title>
      <slot name="title" />
    </v-card-title>
    <v-card-subtitle>
      <slot name="subtitle" />
    </v-card-subtitle>
    <v-card-item>
      <slot name="body" />
    </v-card-item>
  </v-card>
</template>