import { createSlice } from '@reduxjs/toolkit';
import { fetchInsights } from './insightsThunks';

const insightsSlice = createSlice({
  name: 'platformInsights',
  initialState: {
    loading: false,
    error: null,
    insight: null,
    dailyRevenue: [],
  },
  reducers: {},
  extraReducers: builder => {
    builder
      .addCase(fetchInsights.pending, state => {
        state.loading = true;
        state.error = null;
      })
      .addCase(fetchInsights.fulfilled, (state, action) => {
        state.loading = false;
        state.insight = action.payload.insight;
        state.dailyRevenue = action.payload.daily_revenue;
      })
      .addCase(fetchInsights.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });
  },
});

export default insightsSlice.reducer;
