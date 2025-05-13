import 'package:equatable/equatable.dart';

abstract class TableEvent extends Equatable {
  const TableEvent();

  @override
  List<Object?> get props => [];
}

class FetchTables extends TableEvent {
  final int branchId;
  const FetchTables(this.branchId);

  @override
  List<Object?> get props => [branchId];
}
