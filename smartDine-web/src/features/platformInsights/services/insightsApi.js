import request from '../../../utils/remote/axios';
import { requestMethods } from '../../../utils/enums/request.methods';

const insightsApi = {
  getInsights: async (month = null) => {
    try {
      const route = month ? `/insights?month=${month}` : '/insights';
      const response = await request({
        method: requestMethods.GET,
        route,
      });

      if (!response.success) {
        throw new Error(response.message || "Failed to fetch insights");
      }

      return response.data;
    } catch (error) {
      console.error("Insights fetch failed:", error.message);
      return null;
    }
  }
};

export default insightsApi;
