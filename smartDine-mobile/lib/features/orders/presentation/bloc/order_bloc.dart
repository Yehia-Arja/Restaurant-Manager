import 'package:bloc/bloc.dart';
import 'order_event.dart';
import 'order_state.dart';
import '../../domain/usecases/place_order_usecase.dart';

class OrderBloc extends Bloc<OrderEvent, OrderState> {
  final PlaceOrderUseCase _placeOrderUseCase;

  OrderBloc(this._placeOrderUseCase) : super(OrderInitial()) {
    on<PlaceOrderRequested>(_onPlaceOrderRequested);
  }

  Future<void> _onPlaceOrderRequested(PlaceOrderRequested event, Emitter<OrderState> emit) async {
    emit(OrderInProgress());
    try {
      final order = await _placeOrderUseCase(
        productId: event.productId,
        branchId: event.branchId,
        tableId: event.tableId,
      );
      emit(OrderSuccess(order));
    } catch (e) {
      emit(OrderFailure(e.toString()));
    }
  }
}
