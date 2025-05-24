package com.zaleort.second_brain.Memories.Application.UseCases.GetMemories

import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import com.zaleort.second_brain.Memories.Domain.Memory.MemorySearchParams
import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import org.springframework.stereotype.Service

@Service
class GetMemoriesHandler(
    private val memoryRepository: MemoryRepositoryInterface,
) {
    fun execute(command: GetMemoriesCommand): PaginatedResult<MemoryDTO> {
        val searchParams = MemorySearchParams(
            page = command.page,
            limit = command.limit,
            orderBy = command.orderBy,
            orderDirection = command.orderDirection,
            userId = command.userId,
            title = command.title,
            content = command.content,
            type = command.type,
            tags = command.tags,
            createdAtFrom = command.createdAtFrom,
            createdAtTo = command.createdAtTo,
        )

        val result = memoryRepository.search(searchParams)
        return PaginatedResult(
            items = result.items.map { MemoryDTO.fromMemory(it) },
            total = result.total,
            page = result.page,
            limit = result.limit
        )
    }
}