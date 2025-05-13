import 'package:equatable/equatable.dart';
import '../../domain/entities/table_entity.dart';

abstract class TableState extends Equatable {
  const TableState();

  @override
  List<Object?> get props => [];
}

class TableInitial extends TableState {}

class TableLoadInProgress extends TableState {}

class TableLoadSuccess extends TableState {
  final List<TableEntity> tables;
  const TableLoadSuccess(this.tables);

  @override
  List<Object?> get props => [tables];
}

class TableLoadFailure extends TableState {
  final String message;
  const TableLoadFailure(this.message);

  @override
  List<Object?> get props => [message];
}
