import 'package:equatable/equatable.dart';

abstract class OrderEvent extends Equatable {
  const OrderEvent();

  @override
  List<Object?> get props => [];
}

class PlaceOrderRequested extends OrderEvent {
  final int productId;
  final int branchId;
  final int tableNumber;

  const PlaceOrderRequested({
    required this.productId,
    required this.branchId,
    required this.tableNumber,
  });

  @override
  List<Object?> get props => [productId, branchId, tableNumber];
}
