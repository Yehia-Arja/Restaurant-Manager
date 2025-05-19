import { createAsyncThunk } from '@reduxjs/toolkit';
import insightsApi from '../services/insightsApi';

export const fetchInsights = createAsyncThunk(
  'platformInsights/fetchInsights',
  async (month = null) => {
    const response = await insightsApi.getInsights(month);
    return response;
  }
);
