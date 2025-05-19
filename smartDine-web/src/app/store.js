import { configureStore } from '@reduxjs/toolkit';
import platformInsightsReducer from '../features/platformInsights/redux/insightsSlice';

export const store = configureStore({
    reducer: {
        platformInsights: platformInsightsReducer,
    },
});
