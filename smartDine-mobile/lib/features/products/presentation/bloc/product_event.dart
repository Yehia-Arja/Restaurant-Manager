import 'package:equatable/equatable.dart';

abstract class ProductEvent extends Equatable {
  const ProductEvent();

  @override
  List<Object?> get props => [];
}

class LoadProducts extends ProductEvent {
  final int branchId;

  const LoadProducts(this.branchId);

  @override
  List<Object?> get props => [branchId];
}
