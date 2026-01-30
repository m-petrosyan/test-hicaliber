import {defineStore} from 'pinia';
import {reactive, ref} from 'vue';
import axios from 'axios';

export const usePropertyStore = defineStore('property', () => {
    const loading = ref(false);
    const results = ref([]);

    const searchForm = reactive({
        name: '',
        bedrooms: null,
        bathrooms: null,
        storeys: null,
        garages: null,
        price_min: null,
        price_max: null
    });

    const handleSearch = async () => {
        loading.value = true;
        try {
            const params = {};
            Object.keys(searchForm).forEach(key => {
                if (searchForm[key] !== null && searchForm[key] !== '') {
                    params[key] = searchForm[key];
                }
            });

            const response = await axios.get('/api/properties/search', {params});
            results.value = response.data.data;
        } catch (error) {
            console.error('Search failed:', error);
        } finally {
            loading.value = false;
        }
    };

    const resetForm = () => {
        Object.keys(searchForm).forEach(key => {
            searchForm[key] = key === 'name' ? '' : null;
        });
        handleSearch();
    };

    return {
        loading,
        results,
        searchForm,
        handleSearch,
        resetForm
    };
});
