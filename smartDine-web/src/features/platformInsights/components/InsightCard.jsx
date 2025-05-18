import { Card, CardContent } from "../../../components/ui/card";

const InsightCard = ({ label, value, growth = null }) => {
  const isPositive = growth >= 0;

  return (
    <Card className="w-full shadow-sm border border-gray-200">
      <CardContent className="pt-4">
        <div className="text-sm text-gray-500 mb-1">{label}</div>
        <div className="text-2xl font-semibold text-gray-900">{value}</div>

        {growth !== null && (
          <div className={`text-sm font-medium ${isPositive ? "text-green-600" : "text-red-600"}`}>
            {isPositive ? "up" : "down"} {Math.abs(growth)}%
          </div>
        )}
      </CardContent>
    </Card>
  );
};

export default InsightCard;
