import 'package:mobile/features/products/domain/entities/product.dart';

class OrderEntity {
  final int id;
  final Product product;
  final int tableNumber;
  final String status;
  final DateTime createdAt;

  OrderEntity({
    required this.id,
    required this.product,
    required this.tableNumber,
    required this.status,
    required this.createdAt,
  });
}
