import math

def calculate_entropy(data):
    """ 엔트로피 계산 함수 """
    if not data:
        return 0
    
    # Calculate the frequency of each byte value in the data
    frequency = [0] * 256
    for byte in data:
        frequency[byte] += 1
    
    # Calculate the entropy
    entropy = 0
    data_length = len(data)
    for count in frequency:
        if count > 0:
            probability = count / data_length
            entropy -= probability * math.log2(probability)
    
    return entropy

def is_encrypted(file_path, threshold=7.5):
    """ 엔트로피 기반 파일 암호화 여부 판단 """
    with open(file_path, 'rb') as file:
        data = file.read()
        entropy = calculate_entropy(data)
        print(f"Entropy: {entropy}")

        # 임계치보다 높은 경우 암호화로 판단 True 반환
        return entropy > threshold

