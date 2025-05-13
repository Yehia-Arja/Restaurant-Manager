import 'package:mobile/features/products/domain/entities/product.dart';

class OrderEntity {
  final int id;
  final Product product;
  final int tableId;
  final String status;
  final DateTime createdAt;

  OrderEntity({
    required this.id,
    required this.product,
    required this.tableId,
    required this.status,
    required this.createdAt,
  });
}
