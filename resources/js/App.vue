<script setup>
import {usePropertyStore} from './stores/propertyStore';
import {onMounted} from 'vue';
import { Loading } from '@element-plus/icons-vue';

const store = usePropertyStore();

const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(price);
};

onMounted(() => {
  store.handleSearch();
});
</script>

<template>
  <div class="app-container">
    <el-card class="search-card">
      <template #header>
        <div class="card-header">
          <span>Property Search</span>
          <el-icon v-if="store.loading" class="is-loading">
            <Loading />
          </el-icon>
        </div>
      </template>

      <el-form :model="store.searchForm" label-width="120px" @submit.prevent="store.handleSearch">
        <el-row :gutter="20">
          <el-col :span="24">
            <el-form-item label="Name">
              <el-input v-model="store.searchForm.name" placeholder="Search by name..." clearable/>
            </el-form-item>
          </el-col>
        </el-row>

        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item label="Bedrooms">
              <el-input-number v-model="store.searchForm.bedrooms" :min="1"/>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item label="Bathrooms">
              <el-input-number v-model="store.searchForm.bathrooms" :min="1"/>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item label="Storeys">
              <el-input-number v-model="store.searchForm.storeys" :min="1"/>
            </el-form-item>
          </el-col>
        </el-row>

        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item label="Garages">
              <el-input-number v-model="store.searchForm.garages" :min="1"/>
            </el-form-item>
          </el-col>
          <el-col :span="16">
            <el-form-item label="Price Range">
              <div class="price-range">
                <el-input-number v-model="store.searchForm.price_min" :min="1" placeholder="Min"/>
                <span class="range-separator">-</span>
                <el-input-number v-model="store.searchForm.price_max" :min="1" placeholder="Max"/>
              </div>
            </el-form-item>
          </el-col>
        </el-row>

        <el-form-item>
          <el-button type="primary" :loading="store.loading" @click="store.handleSearch">Search</el-button>
          <el-button @click="store.resetForm">Reset</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-divider/>

    <el-table
        v-loading="store.loading"
        :data="store.results"
        style="width: 100%"
        border
        stripe
    >
      <el-table-column prop="name" label="Name" sortable/>
      <el-table-column prop="bedrooms" label="Bedrooms" width="100"/>
      <el-table-column prop="bathrooms" label="Bathrooms" width="100"/>
      <el-table-column prop="storeys" label="Storeys" width="100"/>
      <el-table-column prop="garages" label="Garages" width="100"/>
      <el-table-column prop="price" label="Price" sortable>
        <template #default="scope">
          {{ formatPrice(scope.row.price) }}
        </template>
      </el-table-column>

      <template #empty>
        <el-empty v-if="!store.loading" description="No properties found matching your criteria"/>
      </template>
    </el-table>
  </div>
</template>

<style scoped>
.app-container {
  max-width: 1000px;
  margin: 40px auto;
  padding: 20px;
}

.search-card {
  margin-bottom: 20px;
}

.card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-weight: bold;
  font-size: 1.2rem;
}

.is-loading {
  font-size: 1.5rem;
  color: #409eff;
}

.price-range {
  display: flex;
  align-items: center;
  gap: 10px;
}

.range-separator {
  color: #909399;
}

:deep(.el-input-number) {
  width: 120px;
}

.price-range :deep(.el-input-number) {
  width: 180px;
}
</style>
