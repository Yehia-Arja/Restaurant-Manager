import '../../domain/entities/order_entity.dart';
import 'package:mobile/features/products/data/models/product_model.dart';

class OrderModel extends OrderEntity {
  OrderModel({
    required int id,
    required ProductModel productModel,
    required int tableId,
    required String status,
    required DateTime createdAt,
  }) : super(
         id: id,
         product: productModel.toEntity(),
         tableId: tableId,
         status: status,
         createdAt: createdAt,
       );

  factory OrderModel.fromJson(Map<String, dynamic> json) {
    return OrderModel(
      id: json['id'] as int,
      productModel: ProductModel.fromJson(json['product'] as Map<String, dynamic>),
      tableId: json['table_id'] as int,
      status: json['status'] as String,
      createdAt: DateTime.parse(json['created_at'] as String),
    );
  }
}
