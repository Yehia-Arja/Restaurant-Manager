import 'package:bloc/bloc.dart';
import 'table_event.dart';
import 'table_state.dart';
import '../../domain/usecases/get_tables_usecase.dart';

class TableBloc extends Bloc<TableEvent, TableState> {
  final GetTablesUseCase _getTablesUseCase;

  TableBloc(this._getTablesUseCase) : super(TableInitial()) {
    on<FetchTables>(_onFetchTables);
  }

  Future<void> _onFetchTables(FetchTables event, Emitter<TableState> emit) async {
    emit(TableLoadInProgress());
    try {
      final tables = await _getTablesUseCase(event.branchId);
      emit(TableLoadSuccess(tables));
    } catch (e) {
      emit(TableLoadFailure(e.toString()));
    }
  }
}
