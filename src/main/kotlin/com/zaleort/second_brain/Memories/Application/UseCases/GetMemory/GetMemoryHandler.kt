package com.zaleort.second_brain.Memories.Application.UseCases.GetMemory

import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Domain.Memory.Exceptions.MemoryNotFoundException
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryId
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import org.springframework.stereotype.Service

@Service
class GetMemoryHandler(val repository: MemoryRepositoryInterface) {
    fun execute(command: GetMemoryCommand): MemoryDTO {
        val memory = this.repository.findById(MemoryId(command.id))
        if (memory == null) {
            throw MemoryNotFoundException("Memory not found: ${command.id}")
        }

        if (memory.userId.value != command.userId) {
            throw MemoryNotFoundException("Memory not found: ${command.id}")
        }

        return MemoryDTO.fromMemory(memory)
    }
}